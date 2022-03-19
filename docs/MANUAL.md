## Configuration

### Social Login (OAuth 2.0)
Please follow the [Discord instructions](https://discord.com/developers/docs/intro) to create the required ` OAuth client ID` credentials.

Once you have the **Client ID** and **Client Secret** created there, the values must then be entered in the module configuration at: `Administration -> Modules -> Discord Auth -> Settings`.
This page also displays the `Authorized redirect URI`, which must be inserted in Discord in the corresponding field.

### Discord Widget

#### Setup
1. Enable the module via `ACP --> Modules --> Modules List`
2. Go into your Discord server settings, under Widget you'll see your server id (Will be needed!) place the server id after this url `https://discord.com/widget?id=` and follow the next step
3. In `ACP --> Discord Settings` place your Discord Widget URL in the configuration option then save and now you're done.

#### CSP
- Requires frame-src `https://discord.com` in case you've overwritten the default csp header.

```php
"frame-src" => [
   "self" => true,
   "allow" => [
       'https://discord.com'
   ]
],
```
