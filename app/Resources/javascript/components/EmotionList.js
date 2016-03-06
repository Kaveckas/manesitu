import React from 'react';
import { createIcon } from './../utils';
import Padekit from "./../../images/padekit.svg";
import Liudnas from "./../../images/liudnas.svg";
import Pavarges from "./../../images/pavarges.svg";
import Issigandes from "./../../images/issigandes.svg";
import Sutrikes from "./../../images/sutrikes.svg";
import Susierzines from "./../../images/susierzines.svg";

/**
 *
 * @returns {JSX}
 * @constructor
 */
export const EmotionList = (props) => {
    return (
        <ul className="reaction-list clearfix">
            <li className="reaction-item" id="help" onClick={() => props.changeEmotion('help')}>
                <span
                    className="reaction-icon"
                    dangerouslySetInnerHTML={createIcon(Padekit)}
                ></span>
                <span className="reaction-title">Padėkit!</span>
            </li>
            <li className="reaction-item" id="sad" onClick={() => props.changeEmotion('sad')}>
                <span
                    className="reaction-icon"
                    dangerouslySetInnerHTML={createIcon(Liudnas)}
                ></span>
                <span className="reaction-title">Liūdnas</span>
            </li>
            <li className="reaction-item" id="tired" onClick={() => props.changeEmotion('tired')}>
                <span
                    className="reaction-icon"
                    dangerouslySetInnerHTML={createIcon(Pavarges)}
                ></span>
                <span className="reaction-title">Pavargęs</span>
            </li>
            <li className="reaction-item" id="frightened" onClick={() => props.changeEmotion('frightened')}>
                <span
                    className="reaction-icon"
                    dangerouslySetInnerHTML={createIcon(Issigandes)}
                ></span>
                <span className="reaction-title">Išsigandęs</span>
            </li>
            <li className="reaction-item" id="upset" onClick={() => props.changeEmotion('upset')}>
                <span
                    className="reaction-icon"
                    dangerouslySetInnerHTML={createIcon(Sutrikes)}
                ></span>
                <span className="reaction-title">Sutrikęs</span>
            </li>
            <li className="reaction-item" id="frustrated" onClick={() => props.changeEmotion('frustrated')}>
                <span
                    className="reaction-icon"
                    dangerouslySetInnerHTML={createIcon(Susierzines)}
                ></span>
                <span className="reaction-title">Susierzinęs</span>
            </li>
        </ul>
    )
};
