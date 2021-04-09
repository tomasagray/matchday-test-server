<?php
namespace matchday;

function display_html_events(array $events): void
{
    ?>

    <html lang="en">
    <head>
        <title>Test Football Match Server</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
    <h1>Football Matches</h1>
    <div class="matches-container">
        <?php foreach ($events as $event): ?>
            <div class="match-card">
                <div class="competition-title-container">
                    <p class="competition-title"><?php echo $event->getCompetition()->getName(); ?></p>
                    <p><?php echo date_format($event->getTimestamp(), 'm/d/y'); ?></p>
                </div>
                <div class="teams-container">
                    <p class="team home"><?php echo $event->getHome()->getName(); ?></p>
                    <p style="font-weight: bold;">vs.</p>
                    <p class="team away"><?php echo $event->getAway()->getName(); ?></p>
                </div>
                <div class="parts-container">
                    <?php foreach ($event->getParts() as $part): ?>
                        <a href="<?php echo $part; ?>">
                            <?php
                            $pathinfo = pathinfo($part);
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
?>
