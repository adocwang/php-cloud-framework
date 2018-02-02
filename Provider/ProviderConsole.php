<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 15:24
 */

namespace PhpCloud\Framework\Provider;

use Symfony\Component\Console;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ProviderConsole
{
    private $consoleOutput;
    public static $debugMode;

    public function __construct($debug = false)
    {
        self::$debugMode = $debug;
        $this->consoleOutput = new Console\Output\ConsoleOutput();
        $normalStyle = new OutputFormatterStyle('white');
        $this->consoleOutput->getFormatter()->setStyle('normal', $normalStyle);
        $this->consoleOutput->getFormatter()->setStyle('debug', $normalStyle);
        $errorStyle = new OutputFormatterStyle('red');
        $this->consoleOutput->getFormatter()->setStyle('error', $errorStyle);
    }

    private function formatMessage($message, $tag = 'normal')
    {
        $newMessage = '';
        if (!is_string($message)) {
            if (is_array($message)) {
                foreach ($message as $line) {
                    $newMessage .= print_r($line, true) . " ";
                }
            } else {
                $newMessage = print_r($message, true);
            }
        } else {
            $newMessage = $message;
        }
        $newMessage = date('Y-m-d H:i:s') . ' [' . $tag . '] <' . $tag . '>' . $newMessage . ' </' . $tag . '>';
        return $newMessage;
    }

    public function debug($message)
    {
        if (self::$debugMode) {
            $this->consoleOutput->writeln($this->formatMessage($message, 'debug'));
        }
    }

    public function info($message)
    {
        $this->consoleOutput->writeln($this->formatMessage($message, 'info'));
    }

    public function error($message)
    {
        $this->consoleOutput->writeln($this->formatMessage($message, 'error'));
    }
}