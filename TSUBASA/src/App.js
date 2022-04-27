import React from "react";
import { Routes, Route, BrowserRouter } from "react-router-dom";
import "./App.css";
import { Header } from "./components/Header";
import { ClientPage } from "./Pages/ClientPage";
import { LoginPage } from "./Pages/LoginPage";
import { MyPage } from "./Pages/MyPage";
import { AddItemPage } from "./Pages/AddItemPage";
import { SignUpPage } from "./Pages/SignUpPage";

export function App() {
  return (
    <>
      <div className="App">
        <Header />
        <BrowserRouter>
          <Routes>
            <Route exact path="/items" element={<ClientPage />} />
            <Route exact path="/" element={<LoginPage />} />
            <Route exact path="/signin" element={<LoginPage />} />
            <Route exact path="/additem" element={<AddItemPage />} />
            <Route exact path="/signup" element={<SignUpPage />} />
            <Route exact path="/mypage" element={<MyPage />} />
          </Routes>
        </BrowserRouter>
      </div>
    </>
  );
}

export default App;
