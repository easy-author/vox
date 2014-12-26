<?php
use Behat\MinkExtension\Context\MinkContext;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @Given /^user "([^"]+)" with password "([^"]+)" exists$/
     */
    public function ensureUserWithCredentials($login, $pass)
    {
        // TODO - this should create entry in user repository - but for now, we use fake repository
    }

    /**
     * @Given /^I am authenticated with login "([^"]+)" and password "([^"]+)"$/
     */
    public function authenticatedWithCredentials($login, $pass)
    {
        $this->visit('/admin/login');

        $table = new \Behat\Gherkin\Node\TableNode(
            array(
                array('login', $login),
                array('password', $pass)
            )
        );
        $this->fillFields($table);

        $this->pressButton('Login');
    }
}
