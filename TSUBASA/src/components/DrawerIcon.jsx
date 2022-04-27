import React, { useEffect, useState } from "react";
import GuestIcon from "../image/9984792i.jpeg";
import Icon from "../image/79b2b6041672c2b41c7bffca32c1df4a.png";
//fireBase
import { onAuthStateChanged } from "firebase/auth";
import { auth } from "../FirebaseConfig";

export function DrawerIcon() {
  const [user, setUser] = useState("");
  //firebaseログインしてるか確認
  useEffect(() => {
    onAuthStateChanged(auth, (currentUser) => {
      setUser(currentUser);
    });
  }, []);

  return (
    <>
      <div className="DrawerIcon">
        {user ? (
          <img className="Icon" src={Icon} />
        ) : (
          <img className="Icon" src={GuestIcon} />
        )}
      </div>
      {user ? (
        <p className="mail">{user.email}</p>
      ) : (
        <p className="mail">Hello, Guest</p>
      )}
    </>
  );
}
export default DrawerIcon;
