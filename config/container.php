<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final
 */
class ProjectServiceContainer extends Container
{
    private $parameters = [];

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = [];
        $this->methodMap = [
            'App\\Controller\\OrderController' => 'getOrderControllerService',
            'App\\Controller\\TestController' => 'getTestControllerService',
        ];
        $this->aliases = [
            'order_controller' => 'App\\Controller\\OrderController',
        ];
    }

    public function compile(): void
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled(): bool
    {
        return true;
    }

    public function getRemovedIds(): array
    {
        return [
            '.abstract.instanceof.App\\Mailer\\GmailMailer' => true,
            '.abstract.instanceof.App\\Texter\\SmsTexter' => true,
            '.instanceof.App\\HasLoggerInterface.0.App\\Mailer\\GmailMailer' => true,
            '.instanceof.App\\HasLoggerInterface.0.App\\Texter\\SmsTexter' => true,
            'App\\Database\\Database' => true,
            'App\\Database\\MongoDb' => true,
            'App\\Logger' => true,
            'App\\Mailer\\Email' => true,
            'App\\Mailer\\GmailMailer' => true,
            'App\\Mailer\\MailerInterface' => true,
            'App\\Mailer\\SmtpMailer' => true,
            'App\\Model\\Order' => true,
            'App\\Texter\\FaxTexter' => true,
            'App\\Texter\\SmsTexter' => true,
            'App\\Texter\\Text' => true,
            'App\\Texter\\TexterInterface' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
        ];
    }

    /**
     * Gets the public 'App\Controller\OrderController' shared autowired service.
     *
     * @return \App\Controller\OrderController
     */
    protected function getOrderControllerService()
    {
        $a = ($this->privates['App\\Mailer\\GmailMailer'] ?? $this->getGmailMailerService());
        $b = new \App\Texter\SmsTexter('service.sms.com', 'apikey1234', $a, 'Julien');
        $b->setLogger(($this->privates['App\\Logger'] ?? ($this->privates['App\\Logger'] = new \App\Logger())));

        return $this->services['App\\Controller\\OrderController'] = new \App\Controller\OrderController(new \App\Database\Database(), $a, $b, 'Julien');
    }

    /**
     * Gets the public 'App\Controller\TestController' shared autowired service.
     *
     * @return \App\Controller\TestController
     */
    protected function getTestControllerService()
    {
        return $this->services['App\\Controller\\TestController'] = new \App\Controller\TestController(new \App\Database\MongoDb(), ($this->privates['App\\Mailer\\GmailMailer'] ?? $this->getGmailMailerService()));
    }

    /**
     * Gets the private 'App\Mailer\GmailMailer' shared autowired service.
     *
     * @return \App\Mailer\GmailMailer
     */
    protected function getGmailMailerService()
    {
        $this->privates['App\\Mailer\\GmailMailer'] = $instance = new \App\Mailer\GmailMailer('lior@gmail.com', '123456');

        $instance->setLogger(($this->privates['App\\Logger'] ?? ($this->privates['App\\Logger'] = new \App\Logger())));

        return $instance;
    }

    public function getParameter(string $name)
    {
        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter(string $name, $value): void
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag(): ParameterBagInterface
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = [];
    private $dynamicParameters = [];

    private function getDynamicParameter(string $name)
    {
        throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
    }

    protected function getDefaultParameters(): array
    {
        return [
            'mailer.gmail_user' => 'lior@gmail.com',
            'mailer.gmail_password' => '123456',
        ];
    }
}
