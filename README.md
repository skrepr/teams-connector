<a href="https://skrepr.com/">
  <p align="center">
    <img width="200" height="100" src="https://skrepr.com/theme/skrepr/img/skrepr.svg?a3d5f79941" alt="skrepr" />
  </p>
</a>
<h1 align="center">Teams connector</h1>
<div align="center">
  <a href="https://github.com/skrepr/teams-connector/releases"><img src="https://img.shields.io/github/release/skrepr/teams-connector.svg" alt="Releases"/></a><a> </a>
  <a href="https://github.com/skrepr/teams-connector/blob/master/LICENSE"><img src="https://img.shields.io/github/license/skrepr/teams-connector" alt="LICENSE"/></a><a> </a>
  <a href="https://github.com/skrepr/teams-connector/issues"><img src="https://img.shields.io/github/issues/skrepr/teams-connector.svg" alt="Issues"/></a><a> </a>
  <a href="https://github.com/skrepr/teams-connector/pulls"><img src="https://img.shields.io/github/issues-pr/skrepr/teams-connector.svg" alt="PR"/></a><a> </a>
  <a href="https://github.com/skrepr/teams-connector/commits"><img src="https://img.shields.io/github/commit-activity/m/skrepr/teams-connector" alt="Commits"/></a><a> </a>
  <a href="https://github.com/skrepr/teams-connector/stars"><img src="https://img.shields.io/github/stars/skrepr/teams-connector.svg" alt="Stars"/></a><a> </a>
  <a href="https://github.com/skrepr/teams-connector/releases"><img src="https://img.shields.io/github/forks/skrepr/teams-connector.svg" alt="Forks"/></a><a> </a>
</div>

This package allows you to send notifications to Microsoft Teams.

## Installation

You can install the package using the [Composer](https://getcomposer.org/) package manager. You can install it by running this command in your project root:

```sh
composer require skrepr/teams-connector
```

Then [create an incoming webhook](https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook) on your Microsoft teams channel for the package to use.

## Basic Usage

### Create a simple card

```php
<?php

declare(strict_types=1);

use Skrepr\TeamsConnector\Card;
use Skrepr\TeamsConnector\CardInterface;
use Skrepr\TeamsConnector\Client;

$endPoint = 'https://...';
$httpClient = new \GuzzleHttp\Client();
$teamsClient = new Client($endPoint, $httpClient);

$card = (new Card('Larry Bryant created a new task'))
    ->setText('Yes, he did')
    ->setThemeColor(CardInterface::STATUS_DEFAULT)
    ->setTitle('Adding Title to the card');

$teamsClient->send($card);
```

### Adding a section
```php
<?php

declare(strict_types=1);

use Skrepr\TeamsConnector\Card;
use Skrepr\TeamsConnector\Client;
use Skrepr\TeamsConnector\Section\Section;

$endPoint = 'https://...';
$httpClient = new \GuzzleHttp\Client();
$teamsClient = new Client($endPoint, $httpClient);

$card = new Card('Larry Bryant created a new task');

$section = (new Section('![TestImage](https://47a92947.ngrok.io/Content/Images/default.png)Larry Bryant created a new task'))
    ->setActivitySubtitle('On Project Tango')
    ->setActivityImage('https://teamsnodesample.azurewebsites.net/static/img/image5.png')
    ->addFact('Assigned to', 'Unassigned')
    ->addFact('Due date', 'Mon May 01 2017 17:07:18 GMT-0700 (Pacific Daylight Time)');

$card->addSection($section);

$teamsClient->send($card);
```

### Adding actions and inputs to the card
```php
<?php

declare(strict_types=1);

use Skrepr\TeamsConnector\Actions\ActionCard;
use Skrepr\TeamsConnector\Actions\HttpPostAction;
use Skrepr\TeamsConnector\Card;
use Skrepr\TeamsConnector\Client;
use Skrepr\TeamsConnector\Inputs\TextInput;

$endPoint = 'https://...';
$httpClient = new \GuzzleHttp\Client();
$teamsClient = new Client($endPoint, $httpClient);

$card = new Card('Larry Bryant created a new task');
$card->setText('Yes, he did');

$actionCard = (new ActionCard('Add a comment'))
    ->addInput(new TextInput('comment', 'Add a comment here for this task'))
    ->addAction(new HttpPostAction('Add comment', 'http://...'));

$card->addPotentialAction($actionCard);

$teamsClient->send($card);
```

### HTTP Clients
In order to talk to Microsoft Teams API, you need an HTTP adapter. We rely on HTTPlug
which defines how HTTP message should be sent and received. You can use any library to send HTTP messages
that implements [php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation).

## Testing
``` bash
composer test
```

## Credits
- [Skrepr](https://skrepr.com)
- [Evert Jan Hakvoort](https://github.com/EJTJ3)
- [Jon Mulder](https://github.com/jonmldr)
- [All Contributors](../../contributors)

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
