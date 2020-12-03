var glob = require("glob");
const entryArray = glob.sync('./apps/*.js');
const entryObject = entryArray.reduce((acc, item) => {
    const name = item.split('/').pop().replace('.js','');
    acc[name] = item;
    return acc;
}, {});

module.exports = {
    entry: entryObject, 
    output: {
      path: __dirname + "/dist",
      filename: "[name].js"
    },
    module: {
      rules: [
        {
          test: /.js$/,
          loader: "babel-loader",
          exclude: /node_modules/
        },
        {
          test: /\.s[ac]ss$/i,
          use: [
            "style-loader",
            "css-loader",
            "sass-loader",
          ],
        },
      ],
    }
  };
  