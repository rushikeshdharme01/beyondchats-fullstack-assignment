function llmMock(original, competitors) {
  return `
Improved Article (Generated)

${original.content}

This version is enhanced based on competitor insights:
- ${competitors[0].url}
- ${competitors[1].url}
`;
}

module.exports = llmMock;
