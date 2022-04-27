import React, { useState } from "react";

//結果を表示する機能
export const Create = () => {
  const handleClick = (e) => {
    e.preventDefault();
    console.log(
      `seller-id:${id}\nitem-code:${itemCode}\nname:${name}\npath:${path}\nprice:${price}`
    );
    setId("");
    setItemCode("");
    setName("");
    setPath("");
    setPrice("");
    setSuccess(`id:${id}\n
        item-code:${itemCode}\nname:${name}\npath:${path}\nprice:${price}\nを送信しました`);
  };

  //商品詳細のuseState
  const [id, setId] = useState("");
  const [itemCode, setItemCode] = useState("");
  const [name, setName] = useState("");
  const [path, setPath] = useState("");
  const [price, setPrice] = useState("");

  //送信した結果を表示するuseState
  const [success, setSuccess] = useState("");

  return (
    <>
      <h1 className="create-name">商品登録画面</h1>
      <form onSubmit={handleClick} className="create-form">
        <div>
          <label>Seller-ID</label>
          <input
            name="seller-id"
            type="text"
            placeholder="seller id"
            value={id}
            required
            onChange={(e) => setId(e.target.value)}
          />
        </div>
        <div>
          <label>Item-Code</label>
          <input
            name="item-code"
            type="text"
            placeholder="item-code"
            value={itemCode}
            required
            onChange={(e) => setItemCode(e.target.value)}
          />
        </div>
        <div>
          <label>商品名</label>
          <input
            type="text"
            placeholder="name"
            value={name}
            required
            onChange={(e) => setName(e.target.value)}
          />
        </div>
        <div>
          <label>パス</label>
          <input
            type="text"
            placeholder="path"
            value={path}
            required
            onChange={(e) => setPath(e.target.value)}
          />
        </div>
        <div>
          <label>価格</label>
          <input
            type="text"
            placeholder="price"
            value={price}
            required
            onChange={(e) => setPrice(e.target.value)}
          />
        </div>
        <p>
          <button type="submit">submit</button>
        </p>
        <p>{success}</p>
      </form>
    </>
  );
};
