const fetchLatest = require("./services/fetchLatest");
const googleMock = require("./services/googleMock");
const llmMock = require("./services/llmMock");
const publishGenerated = require("./services/publish");

(async () => {
  const latest = await fetchLatest();
  const competitors = googleMock(latest.title);
  const improved = llmMock(latest, competitors);

  await publishGenerated(
    latest.title,
    improved,
    competitors.map(c => c.url)
  );

  console.log("Generated article published successfully");
})();
