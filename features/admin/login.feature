Feature: Login/Logout
  In order to add content I need to log in into administrative panel

  Background:
    Given user "test" with password "test" exists
    And I am on the homepage

  Scenario: Log in with login and password
    Given I am on "admin/login"
    When I fill in the following:
      | login | test |
      | password | test |
    And I press "Login"
    Then I should be on "/admin/"
    And I should see an "a[href*=logout]" element

  Scenario: Log in bad credentials
    Given I am on "/admin/login"
    When I fill in the following:
      | login | foo |
      | password | bar |
    And I press "Login"
    Then I should be on "/admin/login/"
    And I should see an "li.alert-danger" element

  Scenario: Check "I am authenticated with" proper credentials
    Given I am authenticated with login "test" and password "test"
    Then I should be on "/admin/"
    And I should see an "a[href*=logout]" element

  Scenario: Check "I am authenticated with" wrong credentials
    Given I am authenticated with login "foo" and password "bar"
    Then I should be on "/admin/login/"
    And I should see an "li.alert-danger" element
