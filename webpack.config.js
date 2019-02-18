const path              = require( 'path' );
const webpack           = require( 'webpack' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );

// Configuration for the ExtractTextPlugin.
const extractConfig = {
  use: [
    {loader: 'raw-loader'},
    {
      loader:  'postcss-loader',
      options: {
        plugins: [require( 'autoprefixer' )],
      },
    },
    {
      loader: 'sass-loader',
      query:  {
        outputStyle:
            'production' === process.env.NODE_ENV ? 'compressed' : 'nested',
      },
    },
  ],
};

module.exports = {
  entry:   {
    './js/opt-out-block': './blocks/opt-out.js',
  },
  output:  {
    path:     path.resolve( __dirname ),
    filename: '[name].js',
  },
  watch:   true,
  devtool: 'cheap-eval-source-map',
  module:  {
    rules: [
      {
        test:    /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use:     {
          loader: 'babel-loader',
        },
      },
    ],
  },
};
