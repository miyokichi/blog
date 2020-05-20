<?php

namespace view;

class WebsiteFooter
{
    public static function output()
    {
        ?>
        <footer class="footer">
            <p class='footer_text'>© All rights reserved by <?=\Setting::WEBSITE_NAME?></p>
        </footer>
        <?php
    }
}
