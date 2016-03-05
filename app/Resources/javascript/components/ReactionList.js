import React from 'react';
import Padekit from "./../../images/padekit.svg";
import Liudnas from "./../../images/liudnas.svg";
import Pavarges from "./../../images/pavarges.svg";
import Issigandes from "./../../images/issigandes.svg";
import Sutrikes from "./../../images/sutrikes.svg";
import Susierzines from "./../../images/susierzines.svg";

/**
 *
 * @param icon
 * @returns {{__html: string}}
 */
const createIcon = icon => { return { __html: icon }; };

/**
 *
 * @returns {JSX}
 * @constructor
 */
export const ReactionList = () => {
    return (
        <ul className="reaction-list clearfix">
            <li className="reaction-item">
                        <span
                            className="reaction-icon"
                            dangerouslySetInnerHTML={createIcon(Padekit)}
                        ></span>
                <span className="reaction-title">Padėkit!</span>
            </li>
            <li className="reaction-item">
                        <span
                            className="reaction-icon"
                            dangerouslySetInnerHTML={createIcon(Liudnas)}
                        ></span>
                <span className="reaction-title">Liūdnas</span>
            </li>
            <li className="reaction-item">
                        <span
                            className="reaction-icon"
                            dangerouslySetInnerHTML={createIcon(Pavarges)}
                        ></span>
                <span className="reaction-title">Pavargęs</span>
            </li>
            <li className="reaction-item">
                        <span
                            className="reaction-icon"
                            dangerouslySetInnerHTML={createIcon(Issigandes)}
                        ></span>
                <span className="reaction-title">Išsigandęs</span>
            </li>
            <li className="reaction-item">
                        <span
                            className="reaction-icon"
                            dangerouslySetInnerHTML={createIcon(Sutrikes)}
                        ></span>
                <span className="reaction-title">Sutrikęs</span>
            </li>
            <li className="reaction-item">
                        <span
                            className="reaction-icon"
                            dangerouslySetInnerHTML={createIcon(Susierzines)}
                        ></span>
                <span className="reaction-title">Susierzinęs</span>
            </li>
        </ul>
    )
};
