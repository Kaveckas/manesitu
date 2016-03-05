import React from 'react';
import { Link } from 'react-router';
import './../../styles/home.css';

/**
 *
 * @returns {JSX}
 * @constructor
 */
export const Home = () => {
    return (
        <div className="row">
            <div className="col-xs-12">
                <h1 className="title">
                    <span>Man</span><br/>
                    <span>esi</span><br/>
                    <span>tu</span>
                </h1>
                <ul className="menu">
                    <li className="menu-item">
                        <Link to="/join">Man sunku</Link>
                    </li>
                    <li className="menu-item">
                        <Link to="/">Aš noriu padėti</Link>
                    </li>
                </ul>
                <Link className="browse" to="/posts">Tik panaršysiu</Link>
            </div>
        </div>
    );
};
