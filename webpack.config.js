const path = require('path');

module.exports = {
  entry: {
    bundle: './html/assets/ts/app.ts',
  },
  output: {
    path: path.join(__dirname, './html/assets/dist'),
    filename: '[name].js',
  },
  watch: true,
  resolve: {
    extensions: ['.ts', '.js'],
  },
  module: {
    rules: [
      {
        // 拡張子が.tsで終わるファイルに対して、TypeScriptコンパイラを適用する
        test: /\.ts$/,
        loader: 'ts-loader',
      },
    ],
  },
};
