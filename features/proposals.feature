Feature: Sending proposals to C4P
    As a potential speaker
    I want to send a new proposal to a C4P
    So it can be reviewed

    Scenario: First time proposal
        Given Fran has a proposal with the following content:
        """
        {
            "title": "Proposal Title",
            "description": "A description or abstract of the proposal",
            "autor": "Fran Iglesias",
            "email": "fran.iglesias@ezxample.com",
            "type": "talk",
            "sponsored": true,
            "location": "Vigo, Galicia"
        }
        """
        When He sends the proposal
        Then The proposal is acknowledged
        Then The proposal appears in the list of sent proposals