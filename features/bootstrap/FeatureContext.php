<?php
use Behat\MinkExtension\Context\MinkContext;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @Given /^I am authenticated with login "([^"]+)" and password "([^"]+)"$/
     */
    public function authenticatedWithCredentials($user, $pass)
    {
        $this->visit('/admin/login');

        $table = new \Behat\Gherkin\Node\TableNode(
            array(
                array('login', $user),
                array('password', $pass)
            )
        );
        $this->fillFields($table);

        $this->pressButton('Login');
    }
}
