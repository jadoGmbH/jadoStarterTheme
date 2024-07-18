<!doctype html>
<html lang="<?php echo get_bloginfo('language'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo __('Maintenance Mode', 'jadotheme'); ?></title>
</head>
<body style="background: #ccc; padding: 0; margin: 0;">
<div id="container" style="height: 100vh; display: flex; flex-direction:column; justify-content: center;">
    <p style="font-family: sans-serif; display: block; text-align: center;"><?php echo bloginfo('name'); ?></p>
    <h2 style="font-family: sans-serif; display: block; text-align: center; text-transform: uppercase; letter-spacing: 0.1em;"><?php echo __('Maintenance Mode', 'jadotheme'); ?></h2>
    <p style="font-family: sans-serif; display: block; text-align: center;"><?php echo __('Please come back later.', 'jadotheme'); ?></p>
</div>
</body>
</html>