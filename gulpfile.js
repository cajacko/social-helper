var config = require('./config.json');
var gulp = require('gulp');

// Run phpunit tests
require('./gulp/phpunit')(gulp);

// Run phpunit tests
require('./gulp/mocha')(gulp);

var jsLintDirs = [
  './**/*.js',
  '!./' + config.libs.npm.dir + '/**/*',
  '!./' + config.libs.composer.dir + '/**/*'
];

// Run Javascript codesniffer to check code styling
require('./gulp/jscs')(gulp, jsLintDirs);

// Run Javascript linter to check code integrity
require('./gulp/jshint')(gulp, jsLintDirs);

var phpLintDirs = [
  './**/*.php',
  '!./' + config.libs.npm.dir + '/**/*',
  '!./' + config.libs.composer.dir + '/**/*'
];

// Run Javascript codesniffer to check code styling
require('./gulp/phpcs')(gulp, phpLintDirs);

// A task to run before commiting any code to git
require('./gulp/pre-commit')(gulp);

// Combine and minify javascript files
require('./gulp/scripts')(gulp);

// Enable browsersync to ease dev
require('./gulp/browsersync')(gulp);

// Run the watch tasks
require('./gulp/watch')(gulp);

// The default gulp task
require('./gulp/default')(gulp);
