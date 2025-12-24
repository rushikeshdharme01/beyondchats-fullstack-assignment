const axios = require("axios");

async function fetchLatest() {
  const res = await axios.get("http://127.0.0.1:8000/api/articles");
  return res.data[0]; // latest article
}

module.exports = fetchLatest;
