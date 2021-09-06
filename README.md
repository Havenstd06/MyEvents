# MyEvents
## An open source project that displays events with the ability to create trips.
### Project for Epitech school, made in VueJS, Laravel, Inertia, Pusher, Laravel Echo, TailwindCSS.

<img src="https://limg.app/i/VqafNt.png/150" style="align-content: center" alt="MyEvents logo">

<hr>


## Installation
* clone the repository: `git clone https://github.com/Havenstd06/MyEvents`
* create a database
* install: `composer install`
* create configuration env file `.env` refer to `.env.example` (`cp .env.example .env`)
* generate a new application key `php artisan key:generate`
* setup database tables: `php artisan migrated`
* create storage link `php artisan storage:link`
* install node_module `npm i && npm run dev` (or npm run prod)

## Setup Socialite Login
* go on [Github](https://github.com/settings/applications/new), [Twitter](https://developer.twitter.com/en/portal/dashboard), [Discord](https://discordapp.com/developers/applications), [Facebook](https://developers.facebook.com/apps/?show_reminder=true) developers page
* create new application
* copy `CLIENT ID` & `CLIENT SECRET`
* paste on `.env` (`CLIENT ID` => `DISCORD_KEY` & `CLIENT SECRET` => `DISCORD_SECRET`, ...same for all socialite)
* add callback URL : `https://YourApp.Domain/login/{github / twitter / discord / facebook}/callback`

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
Please make sure to update tests as appropriate.
