var env = process.env || {};
var NODE_ENV = env.NODE_ENV || 'development';

var path = require('path');

var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var ManifestPlugin = require('webpack-manifest-plugin');
var htmlWebpackPlugin = require('html-webpack-plugin');

var config = {
  context: path.join(__dirname, '..'),
  debug:  true,
  devtool: '#eval-source-map',
  entry: {
    waroftruth: [
      'babel-polyfill',
      './src/index.js'
    ]
  },
  output: {
    filename: '[name].js',
    chunkFilename: '[id].js',
    publicPath: '/',
    path: path.join(__dirname, '../build')
  },
  resolve: {
    alias: {

    }
  },
  resolveLoader: {
    root: path.join(__dirname, '../node_modules')
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'jsx-loader?harmony',
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel',
        query: {}
      },
      {
        test: /\.json$/,
        exclude: /node_modules|schema|stub/,
        loader: 'file-loader'
      },
      {
        test: /\.css$/,
        loaders: ['style', 'css?modules']
      },
      {
        isPNG: true,
        test: /\.png$/,
        loader: 'url?limit=10000&mimetype=image/png'
      },
      {
        test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'url?limit=10000&mimetype=image/svg+xml'
      },
      {
        test: /\.map$/,
        loader: 'null-loader'
      },
      {
        test: /\.(woff(2)?)(\?v=\d+\.\d+\.\d+)?/,
        loader: 'url'
      },
      {
        test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'null-loader'
      },
      {
        test: /\.eot(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'null-loader'
      }
    ],
  },
  sassLoader: {
    includePaths: [
      path.join(__dirname, 'node_modules'),
      path.join(__dirname, './src/client/scss/')
    ]
  },
  plugins: [
    new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /de|fr|hu/),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery'
    }),
    new webpack.DefinePlugin({
      NODE_ENV: JSON.stringify(NODE_ENV),
      'process.env.NODE_ENV': JSON.stringify(NODE_ENV)
    })
  ]
};

if (NODE_ENV === 'production') {
  const minify = {
    minifyCSS: true,
    minifyJS: {},
    collapseWhitespace: true,
    preserveLineBreaks: true
  };

  config.debug = false;
  config.devtool = '';
  config.plugins = config.plugins.concat([
    new ManifestPlugin(),
    new webpack.optimize.UglifyJsPlugin({
      sourceMap: false,
      compress: {
        warnings: false,
      },
    }),
    new webpack.optimize.OccurenceOrderPlugin(true),
    new webpack.NoErrorsPlugin(),

    new htmlWebpackPlugin({
      filename: 'index.html',
      template: '../index.html',
      inject: false,
      minify
    }),

    new htmlWebpackPlugin({
      filename: 'auth.html',
      template: '../auth.html',
      inject: false,
      minify
    }),
  ]);
  config.output.path = path.join(__dirname, '../dist');
  config.output.filename = '[name]-[hash]-min.js';
  config.output.chunkFilename = '[id]-[hash]-min.js';
  config.output.publicPath = '/';
}
else {
  config.plugins.push(new webpack.optimize.OccurenceOrderPlugin());
  config.plugins.push(new webpack.HotModuleReplacementPlugin());
}

module.exports = config;
