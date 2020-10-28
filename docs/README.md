# Discord Sign-In

Using this module, users can directly log in or register with their Discord credentials at their HumHub installation.
A new button "Discord" will appear on the login page as well as in the Connected Accounts of the user's Account Settings.

## Configuration

Please follow the [Discord instructions](https://discord.com/developers/docs/intro) to create the required ` OAuth client ID` credentials.

Once you have the **Client ID** and **Client Secret** created there, the values must then be entered in the module configuration at: `Administration -> Modules -> Discord Auth -> Settings`.
This page also displays the `Authorized redirect URI`, which must be inserted in Discord in the corresponding field.
