const path = require('path');
const validate = require('webpack-validator');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');

var env = 'dev';

if (process.env.npm_lifecycle_event == 'build-production') {
  env = 'production';
}

const PATHS = {
  app: path.join(__dirname, 'app', 'views'),
  build: path.join(__dirname, 'app', 'public', 'scripts')
};

var config = {
  entry: {
    app: PATHS.app
  },

  output: {
    path: PATHS.build,
    filename: '[name].js'
  },

  plugins: [
    new CleanWebpackPlugin([PATHS.build], {
      root: process.cwd()
    }),

    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify(env)
      }
    })
  ],

  resolve: {
    extensions: ['', '.js', '.jsx']
  },

  module: {
    preLoaders: [
      {
        test: /\.(js|jsx)$/,
        loaders: ['eslint'],
        include: PATHS.app
      }
    ],

    loaders: [
      {
        test: /\.(js|jsx)$/,
        loaders: ['babel?cacheDirectory'],
        include: PATHS.app
      },
      {
        test: /\.json$/,
        loader: 'json'
      }
    ]
  }
}

if (env != 'production') {
  config.devtool = 'cheap-module-source-map';
} else {
  config.plugins.push(
    new webpack.optimize.UglifyJsPlugin({
      compress: {
          warnings: false
      }
    })
  );
}

module.exports = validate(config, {
  quiet: true
});
