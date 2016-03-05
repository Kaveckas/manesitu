import React from 'react';

export default class App extends React.Component {
    /**
     *
     * @returns {JSX}
     */
    render() {
        return (
            <div className="app-wrapper col-sm-6 col-sm-offset-3">
                {this.props.children}
            </div>
        );
    }
}
