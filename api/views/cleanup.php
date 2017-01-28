<?php

define('CRON', true);

// Delete old tweets
// Delete any join tables that don't have parents
// Delete any queries not attached to accounts
// Delete any accounts not attached to users
// Delete any tweets not attached to queries
// Delete any auth tokens not attached to users
// Delete old auth tokens
