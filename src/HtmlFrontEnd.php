<?php

namespace Matchday\TestServer;


use Matchday\TestServer\model\Event;

class HtmlFrontEnd
{
    public static function display_html_events(array $events): void
    {
        ?>

        <html lang="en">
        <head>
            <title>Test Football Match Server</title>
            <link rel="stylesheet" href="<?php echo dirname($_SERVER['REQUEST_URI']); ?>styles.css"/>
        </head>
        <body>

        <h1>Football Matches</h1>
        <div id="sub-header-container">
            <div>
                <div id="total-container">
                    <p style="font-weight: bolder;">Total Events:</p>
                    <p><?php echo count($events); ?></p>
                </div>
            </div>
            <div>
                <form action="" method="get" style="margin: 0;">
                    <input type="hidden" name="format" value="json"/>
                    <input id="as-json-button" type="submit" value="As JSON...">
                </form>
            </div>
        </div>
        <div class="matches-container">
            <?php foreach ($events as $event): ?><?php self::print_event($event); ?><?php endforeach; ?>
        </div>
        </body>
        </html>
        <?php
    }

    private static function print_event(Event $event): void
    {
        ?>
        <div class="match-card">
            <div class="competition-title-container">
                <p class="competition-title">
                    <?php echo $event->getCompetition()->getName(); ?>
                </p>
                <p>
                    <?php
                    $date = $event->getDateTime()->getDate();
                    echo "{$date->getMonth()}/{$date->getDay()}/{$date->getYear()}";
                    ?>
                </p>
            </div>
            <div class="teams-container">
                <p class="team home"><?php echo $event->getHomeTeam()->getName(); ?></p>
                <p style="font-weight: bold;">vs.</p>
                <p class="team away"><?php echo $event->getAwayTeam()->getName(); ?></p>
            </div>
            <div class="parts-container">
                <?php
                foreach ($event->getFileSources()[0]->getVideoFilePacks()[0]->getVideoFiles() as $videoFile):
                    $url = $videoFile->getExternalUrl();
                    ?>
                    <a href="<?php echo $url; ?>">
                        <?php
                        $path_info = pathinfo($url);
                        echo $path_info['basename'];
                        ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
