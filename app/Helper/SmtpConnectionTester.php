<?php
/**
 * Created by PhpStorm.
 * User: yahya
 * Date: 15-Dec-18
 * Time: 16:06
 */

namespace App\Helper;


use Graze\TelnetClient\TelnetClient;

class SmtpConnectionTester
{
    protected $telnetClient;
    /**
     * @var array
     */
    private $smtpSettings;

    /**
     * SmtpConnectionTester constructor.
     * @param array $smtpSettings
     */
    public function __construct($smtpSettings = [])
    {
        $this->telnetClient = TelnetClient::factory();
        $this->smtpSettings = $smtpSettings;
    }

    public function testAuth($username = '', $password = '')
    {
        $encodedUsername = base64_encode($username ?: $this->getSettings('username'));
        $encodedPassword = base64_encode($password ?: $this->getSettings('password'));
        $dsn = $this->getSettings('host') . ':' . $this->getSettings('port');

        $this->telnetClient->connect($dsn);
        $this->skipResponse($this->telnetClient->getSocket());
        $responses = [];

        $response = $this->telnetClient->execute("HELO {$this->getSettings('host')}\r", "\r");

        $response = $this->telnetClient->execute("AUTH LOGIN\r", "334 VXNlcm5hbWU6\r");
        $responses[] = $response->getResponseText() . $response->getPromptMatches()[0];
        logger()->debug('AUTH LOGIN response: ', $responses);

        $response = $this->telnetClient->execute($encodedUsername . "\r", "334 UGFzc3dvcmQ6\r");
        $responses[] = $response->getResponseText() . $response->getPromptMatches()[0];
        logger()->debug('username response: ', $responses);

        $response = $this->telnetClient->execute($encodedPassword . "\r", "\r");
        $responses[] = $response->getResponseText() . $response->getPromptMatches()[0];
        logger()->debug('password response: ', $responses);

        try {
            $this->telnetClient->execute("QUIT\r", "\r");
        } catch (\Exception $exception) {
        }

        return $responses;
    }

    protected function getSettings($key)
    {
        return key_exists($key, $this->smtpSettings) ? $this->smtpSettings[$key] : null;
    }

    private function skipResponse(\Socket\Raw\Socket $socket)
    {
        do {
            $char = $socket->read(1);

            if ($char == "\n") {
                break;
            }
        } while (true);
    }
}