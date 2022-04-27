import * as React from "react";
import { useState } from "react";
import PropTypes from "prop-types";
import Typography from "@mui/material/Typography";
import Grid from "@mui/material/Grid";
import Card from "@mui/material/Card";
import CardActionArea from "@mui/material/CardActionArea";
import CardContent from "@mui/material/CardContent";
// import CardMedia from "@mui/material/CardMedia";

fetch(
  `https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid=dj00aiZpPUZPU3h2a21KeG5pVSZzPWNvbnN1bWVyc2VjcmV0Jng9NDQ-&query=西洋絵画&genre_category_id=11561&price_from=1000&price_to=5000&results=100`,
  { mode: "cors" }
)
  .then((res) => res.json())
  .then((data) => console.log(data));

export function Items() {
  const [art, setArt] = useState([]);

  // 検索で入力できるようにするためのsetState
  const [search, setSearch] = useState("");

  // 送信機能
  const handleSubmit = async (e) => {
    await e.preventDefault();

    await fetch(
      `https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid=dj00aiZpPUZPU3h2a21KeG5pVSZzPWNvbnN1bWVyc2VjcmV0Jng9NDQ-&query=${search}&genre_category_id=11561&price_from=1000&price_to=5000&results=100`,
      { mode: "cors" }
    )
      .then((res) => res.json())
      .then((data) => setArt(data.hits));

    if (art.length === 0) {
      return alert("NO data");
    }

    console.log(art.length);
  };

  //いいねuseState
  const [likes, setLikes] = useState(0);
  const [likeMark, setLikeMark] = useState("🤍");

  //いいね機能
  const handleLike = (e, id) => {
    e.preventDefault();
    setLikes(likes + 1);
    setLikeMark("❤️");
  };

  //削除機能
  const handleDelete = (e) => {
    e.preventDefault();
    console.log("delete");
  };

  //検索結果を表示するmap
  const detail = art.map((item, id) => {
    return (
      <Grid item xs={12} md={6} key={id}>
        <CardActionArea component="a" href="#">
          <Card sx={{ display: "flex" }}>
            <CardContent sx={{ flex: 1 }}>
              <Typography component="h2" variant="h5">
                {item.name}
              </Typography>
              <Typography paragraph>{item.description}</Typography>
              <div className="function-wrapper">
                <button className="likeButton" onClick={handleLike}>
                  いいね：
                  {likeMark}
                  {likes}
                </button>
                <span>
                  <Typography color="primary">
                    <a href={item.review.url}>review</a>
                  </Typography>
                </span>
                <span>
                  <Typography color="primary">
                    <a href={item.url}>Continue reading...</a>
                  </Typography>
                </span>
                <span onClick={handleDelete}>delete</span>
              </div>
            </CardContent>
            <div className="searchImageWrapper">
              <img className="searchImage" src={item.image.medium} alt="" />
            </div>
          </Card>
        </CardActionArea>
      </Grid>
    );
  });

  return (
    <>
      <form className="form-wrapper" onSubmit={handleSubmit}>
        <input
          type="text"
          onChange={(e) => setSearch(e.target.value)}
          value={search}
          required
        />
        <button className="search-button" type="submit">
          SEARCH
        </button>
      </form>
      <p className="searchResult"> 検索結果:{art.length}件</p>
      {detail}
    </>
  );
}

//MUI
Items.propTypes = {
  post: PropTypes.shape({
    date: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
    image: PropTypes.string.isRequired,
    imageLabel: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
  }).isRequired,
};
