Feature: API health
  As Consumer
  I want to have a reachable API

    Scenario: Health page
        When I visit "/api/health"
        Then I obtain a 200 status
