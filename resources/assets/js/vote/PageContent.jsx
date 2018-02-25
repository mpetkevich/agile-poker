import React from 'react';

export default class PageContent extends React.PureComponent{

    render(){

        let votes = [];
        for (let i = 1; i <= 10; i++) {
            votes.push( <div key={i} className="col-md-3">
                <button className="btn btn-default voteButton" >{i}</button>
            </div>);
        }

        return (<div className="panel-body">
            <div className="container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <div className="panel panel-default">
                            <div className="panel-heading">Vote Room {this.props.roomID}</div>
                            <div className="panel-body">
                            <div className="row">
                                {votes}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>);
    }
}
