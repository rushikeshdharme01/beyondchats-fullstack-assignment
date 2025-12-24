const axios = require("axios");

async function publishGenerated(title, content, references) {
  await axios.post("http://127.0.0.1:8000/api/articles", {
    title: `${title} (Updated)`,
    content,
    source_type: "generated",
    reference_urls: references
  });
}

module.exports = publishGenerated;
