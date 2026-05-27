import { SiTask } from "react-icons/si";
import Button from "./Button";

import React from 'react'

const NavBar = () => {
    return (
        <div>
            <nav className="flex justify-between items-center px-10 py-5">
                <div className="flex items-center gap-2">
                    <SiTask size={28} />
                    <h3 className="text-xl font-bold">Task Flow</h3>
                </div>

                <ul className="flex items-center gap-5 font-medium cursor-pointer">
                    <li id="#Home">Home</li>
                    <li id="#Features">Features</li>
                    <li id="#Workflows">Workflows</li>
                    <li id="#Contacts">Contact</li>
                    <li id="#About">About</li>
                </ul>

                <div className="flex items-center gap-5 font-medium ">
                    {/* <button className="cursor-pointer border-2 p-2 text-white bg-blue-500 rounded-xl" type="button">Login</button>
                <button className="cursor-pointer border-2 p-2 text-white bg-blue-500 rounded-xl" type="button">Get Started</button> */}

                    <Button title={"Login"}></Button>
                    <Button title={"Get Started"}></Button>
                </div>
            </nav>

        </div>
    )
}

export default NavBar;