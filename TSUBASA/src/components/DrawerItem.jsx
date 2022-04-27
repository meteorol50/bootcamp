import React from "react";
import GroupAddOutlinedIcon from "@mui/icons-material/GroupAddOutlined";
import AccountCircleOutlinedIcon from "@mui/icons-material/AccountCircleOutlined";
import DisplaySettingsOutlinedIcon from "@mui/icons-material/DisplaySettingsOutlined";
import LoginOutlinedIcon from "@mui/icons-material/LoginOutlined";
import SettingsOutlinedIcon from "@mui/icons-material/SettingsOutlined";

export const DrawerItem = [
  {
    title: "SignUp",
    icon: <GroupAddOutlinedIcon />,
    link: "/signup",
  },
  {
    title: "Login",
    icon: <LoginOutlinedIcon />,
    link: "/",
  },
  {
    title: "myPage",
    icon: <SettingsOutlinedIcon />,
    link: "/mypage",
  },
  {
    title: "Client",
    icon: <AccountCircleOutlinedIcon />,
    link: "/items",
  },
  {
    title: "Server",
    icon: <DisplaySettingsOutlinedIcon />,
    link: "/",
  },
];

export default DrawerItem;
