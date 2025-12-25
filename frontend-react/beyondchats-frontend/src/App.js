import { useEffect, useState } from "react";
import "./App.css";

function App() {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);


const API_BASE_URL = process.env.REACT_APP_API_BASE_URL


  useEffect(() => {
    fetch(`${API_BASE_URL}/api/articles`)
      .then((res) => res.json())
      .then((data) => {
        setArticles(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setLoading(false);
      });
  }, [API_BASE_URL]);

  return (
    <div className="container">
      <h1>BeyondChats Articles</h1>

      {loading && <p>Loading articles...</p>}
      {!loading && articles.length === 0 && (
        <p>No articles found.</p>
      )}

      <div className="articles">
        {articles.map((article) => (
          <div className="card" key={article.id}>
            <h2>{article.title}</h2>

            <span className={`badge ${article.source_type}`}>
              {article.source_type.toUpperCase()}
            </span>

            <p>
              {article.content.length > 300
                ? article.content.substring(0, 300) + "..."
                : article.content}
            </p>

            {article.source_url && (
              <a href={article.source_url} target="_blank" rel="noreferrer">
                Read Original
              </a>
            )}
          </div>
        ))}
      </div>
    </div>
  );
}

export default App;
