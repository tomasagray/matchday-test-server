<?php

namespace Matchday\TestServer;


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
        <div id="total-container">
            <p style="font-weight: bolder;">Total Events:</p>
            <p><?php echo count($events); ?></p>
        </div>
        <div class="matches-container">
            <?php foreach ($events as $event): ?>
                <div class="match-card">
                    <div class="competition-title-container">
                        <p class="competition-title"><?php echo $event->getCompetition()->getProperName(); ?></p>
                        <p><?php echo date_format($event->getDate(), 'm/d/y'); ?></p>
                    </div>
                    <div class="teams-container">
                        <p class="team home"><?php echo $event->getHomeTeam()->getProperName(); ?></p>
                        <p style="font-weight: bold;">vs.</p>
                        <p class="team away"><?php echo $event->getAwayTeam()->getProperName(); ?></p>
                    </div>
                    <div class="parts-container">
                        <?php foreach ($event->getFileSources()[0]->getEventFiles() as $eventFile): ?>
                            <a href="<?php echo $eventFile; ?>">
                                <?php
                                $pathinfo = pathinfo($eventFile);
                                echo $pathinfo['basename'];
                                ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </body>
        </html>
        <?php
    }
}
