<?php

namespace JdhmApi\Git\Hook;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Application;

/**
 * Update
 *
 * Will check the code before submited to origin via Git Hook on server
 */
class Prepush extends Application
{
    private $localRef;
    private $localSha;
    private $remoteRef;
    private $remoteSha;
    private $author;
    private $email;
    private $logName;

    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct('Nazi Tool :)', '1.0.0');

        $line = trim(fgets(STDIN));
        $args = explode(" ", $line);

        // Pushing nothing
        if (count($args) != 4) {
            echo "Error in stdin number of args. See ".__DIR__." (line ".__LINE__.")";
            exit(1);
        }

        $this->localRef = $args[0];
        $this->localSha = $args[1];
        $this->remoteRef = $args[2];
        $this->remoteSha = $args[3];
        $this->logName = $_SERVER['LOGNAME'];

        $this->getAuthor($this->localSha);
    }

    /**
     * Run
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $output = $this->createStyles($output);
        $this->checkBranch($output);

        // Welcome
        $this->welcome($output);

        // 1 Changed files
        $this->changedFiles($output);

        // 2 Check shit
        $this->checkStyle('var_dump', $output);

        // Everything okay, push accepted
        $output->writeln("<blue>FINAL:</blue>");
        $output->writeln("<info>→ SUCCESS: your push has been accepted! ☺</info>");
        exit(0);
    }

    /**
     * Just a fancy welcome message
     *
     * @param OutputInterface $output
     */
    private function welcome($output)
    {
        $logo = "

                        e########eee
                       e##~      ~~*###e
                      e##            ~*###e                        ee#######e
                      e##                ~###e                   e###//////###e
                     e##~                   ~################ee##/////////////##e      eeeeeeeeee
                     e##                                    ~##/////////////////##  e##*~      ~*##e
                     e##                                    ##//////////////////*####*~          ~*###e
                     e##e                                 e##/////////ee###ee///###                 ~##e
                     ~###                                e##////////e##/////##e#####ee               ~##
                    e##~                                 ###////////##/////##////////##e  e######e    ##
                   e##~                                  ~##/////////#////##///////////*##////////##e##*
                 e##~                                     ~#//////////##e##/////////////#////////////##e
                e##~                                       ~##///////////##////////////e##ee//////////###
               e##~                                          ~#####eeeeee##e//////////e#///##e/////////##e
               ##~                                                         ~##eeeeee##//////##/////////##e
              e##                                                               ##/##e/////e##////////e##
              ##~                                                               ##///*#####*//////////##~
              ##                                                                ~##/////////////////e##~
              ##                                                                 ##e///////////////e##~
   ###############e            e@@@e                                              ##e////////////e###~
              ##~######e      e@@@@@e                                              ~##eeeeeeee###~ ###
              ##             e@@@@@@@                                                              ###
              ##             @@@@@@@@                                                              ###
      e##############e        *@@@@@~                                        e@@@e                 ###
              ###                                                           e@@@@@e           ###############ee
               ##e                                    ///////              @@@@@@@@@               ##~      ~###e
             eee########e                           //////////             @@@@@@@@                ##
         e#####*~##e                                //////////              *@@@@*            #######eee
                  ~##e                               ///////                                     e##~*#####ee
                    ~##e                                                                    e##ee##~      ~#*
              ee#########e                                                                    ~#####e
            e##~      ~*####e                                                                ###~  ####e
          e##~          e#~*####ee                                                        e###~      ~####e
         e##~         e##~   ~########ee                                                e###~
         e##         e##~     e#//////##########eee                               eeee###*~
         e##        e##~    e##///////##~      ***#########eeeeeeeeeeeeeeeee#######*~
          e##     e##~     e##/////////##e                  e###///////########eee
           e##   e##~     e##///////////##e               e###///////e##~      ~###eee
            e##e##~      ###/////////////##ee         ee###////////e##~           ~*##ee
             ~####e    e##/////      //////##eeeeeeee###///////////e##               e###e
                ~*###ee##/////         /////////////////////    ///e##             e##~ ~##e
                    ~*##//////         ///////////////////        //##e         e##*~    ~##e
                     e##//////         //////////////////          //##e      e##*~        ##e
                    e##////////       ///////////////////          ///##e  ee##~            ##e
                    e##//////////////////////////////////          /////####*~               ##e
                    ##/////////////////////////////////////      /////////##e                ##e
                   e##/////////////////////////////////////////////////////##                ##e
                   ###/////////////////////////////////////////////////////##eee#eee      ee##~
                   ###/////////////////////////////////////////////////////////## ~*#######*~
                   ###/////////////////////////////////////////////////////////##
                   ###/////////////////////////////////////////////////////////##
                   ###/////////////////////////##//////////////////////////////##
                   ~############//////////////e##e////////////////////////////##
                   e##~        ~###########eeee#################################
                  e##~                       ~###~                         ~##~
                  ###                         ###                           ##e
                   ##e                       e###e                          ##e
                    ###e                   ee## ##e                        e##
                     ~###eee          eee###*~   *##e                    e##*~
                        ~*#############*~         ~*####eeeeeeeeeeeeeee##*~

        ";

        $output->writeln(sprintf("<magenta>%s</magenta>", $logo));
        $output->writeln("<info>☺ ☺ ☺ ☺ ☺ ☺ ☺ ☺  WILKOMEN IN GITLAB ☺ ☺ ☺ ☺ ☺ ☺ ☺ ☺</info>");

        $output->writeln("");
        $output->writeln(sprintf("<nice>HELLO %s!</nice>", $this->author));
        $output->writeln("");
        $output->writeln(sprintf("<comment>I'm the GITLAB server and you are about to push your code in MY repository, so I'm going to check a few things.</comment>"));
        $output->writeln("");
        $output->writeln(sprintf("<comment>If I accept your push, a build will be automaticaly run by my friend JENKINS. If my friend is happy with it he will merge it in the preprod branch.</comment>"));
        $output->writeln("");
    }

    /**
     * Display changed files
     *
     * @param OutputInterface $output
     */
    private function changedFiles($output)
    {
        $output->writeln(sprintf("<blue>1)- Files you changed</blue>"));
        $output->writeln("");
        $output->writeln(sprintf($this->checkGitStats()));
    }

    /**
     * Make grep in code to find unwated code
     *
     * @param string          $string
     * @param OutputInterface $output
     */
    private function checkStyle($string, $output)
    {
        $output->writeln(sprintf("<blue>2)- Dirty %s you might have left</blue>", $string));
        $output->writeln("");

        $flagFound = shell_exec(sprintf("git grep --color %s HEAD -- `git ls-files | grep -v src/App/Git/`", $string));

        if ($flagFound) {
            $output->writeln($flagFound);
            $output->writeln("<error>☠ ☠ ☠ You left some unwanted code. Reviewing your code would be much appreciated. Thanks :) (DIE MOTHER FUCKER!) ☠ ☠ ☠ </error>");
            exit(1);
        }

        $output->writeln("<info>→ Ok</info>");
        $output->writeln("");
    }

    /**
     * Return git diff command
     *
     * @return strinf
     */
    private function checkGitStats()
    {
        return shell_exec("git diff --stat --cached origin/develop");
    }

    /**
     * Check if client is allowed to push on branch
     *
     * @param OutputInterface $output
     */
    private function checkBranch($output)
    {
        if ($this->remoteRef !== 'refs/heads/develop') {
            $output->writeln("<error>☠ ☠ ☠ You can only push to develop mother fucker! ☠ ☠ ☠ </error>");
            exit(1);
        }
    }

    /**
     * Available styles:
     *     - error
     *
     * @param OutputInterface $output
     *
     * @return OutputInterface
     */
    private function createStyles($output)
    {
        $style = new OutputFormatterStyle('white', 'red', array('bold', 'blink'));
        $output->getFormatter()->setStyle('error', $style);

        $style = new OutputFormatterStyle('white', 'green', array('bold', 'blink'));
        $output->getFormatter()->setStyle('valid', $style);

        $style = new OutputFormatterStyle('white', 'blue', array('bold', 'blink'));
        $output->getFormatter()->setStyle('nice', $style);

        $style = new OutputFormatterStyle('blue');
        $output->getFormatter()->setStyle('blue', $style);

        $style = new OutputFormatterStyle('cyan');
        $output->getFormatter()->setStyle('cyan', $style);

        $style = new OutputFormatterStyle('magenta');
        $output->getFormatter()->setStyle('magenta', $style);

        return $output;
    }

    /**
     * Get the author & email
     *
     * @param string $commitId
     *
     * @throws \Exception
     */
    private function getAuthor($commitId)
    {
        // Jenkins user can do everything
        if ($this->logName === "jenkins") {
            exit(0);
        }

        $data = shell_exec(sprintf('git cat-file -p %s', $commitId));

        if (!preg_match("/author (.*) <(.*)>/", $data, $matches)) {
            throw new \Exception("Couldn't find the author in commit", 1);
        }

        $this->author = $matches[1];
        $this->email = $matches[2];

        // In case logname didn't work
        if ($this->email === 'gitlab@gitlab') {
            exit(0);
        }
    }
}
