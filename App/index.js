var glob = require("glob");
const entryArray = glob.sync('./apps/*.js');
const entryObject = entryArray.reduce((acc, item) => {
  const name = item.split('/').pop().replace('.js','');
  acc[name] = item;
  return acc;
}, {});

console.log(entryObject);