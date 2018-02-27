import React from 'react';
import fetch from 'node-fetch';
import FormData from 'form-data';
import objectAssign from 'object-assign';

export default class PageContent extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            roomVotesList: [],
            myVote: null,
            admin: false,
        };

        this.onClearRoom = this.onClearRoom.bind(this);
    }

    componentDidMount() {
        this.fetchData('/ajax/rooms/' + this.props.roomID + '/voteData');
    }

    fetchData(url, params = {}) {
        let _this = this;

        let fetchParams = objectAssign(
            {
                method: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Cache': 'no-cache',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
                credentials: 'include'
            },
            params
        );

        fetch(url, fetchParams)
            .then(res => res.json())
            .then(json => {

                let state = {};
                if (typeof json.admin !== 'undefined') {
                    state.admin = json.admin;
                }
                if (typeof json.room !== 'undefined') {
                    state.roomVotesList = json.room;
                }
                if (typeof json.vote !== 'undefined') {
                    state.myVote = json.vote;
                }
                _this.setState(state);

            });
    }

    onSetVote(vote) {
        let body = {vote:vote};
        this.fetchData('/ajax/rooms/' + this.props.roomID + '/voteData',{method: 'POST', body: JSON.stringify(body)});
    }
    onClearRoom() {
        this.fetchData('/ajax/rooms/' + this.props.roomID + '/clear',{method: 'POST'});
    }


    renderVoteButtons() {

        if (this.state.myVote !== null) {
            return null;
        }

        let votes = [];

        for (let i = 1; i <= 10; i++) {
            votes.push(<div key={i} className="col-md-3">
                <button className="btn btn-default voteButton" onClick={this.onSetVote.bind(this,i)}>{i}</button>
            </div>);
        }

        return (
            <div className="row">
                {votes}
            </div>
        );
    }

    renderVotes() {

        if (this.state.myVote === null) {
            return null;
        }

        let count = this.state.roomVotesList.length;
        let total = 0;
        let votesList = this.state.roomVotesList.map((vote) => {
            total += vote.vote;
            return (<div key={vote.id}>
                {vote.user.name} {vote.vote}
            </div>);
        });

        total = Math.ceil(total / count);
        return (
            <div>
                <div>Estimate <span>{total}</span></div>
                {votesList}
            </div>
        );
    }

    renderAdminButtons() {

        if (!this.state.admin) {
            return null;
        }

        return (
            <div className="panel panel-default">
                <div className="panel-body">
                    <button type="button" className="btn btn-info" onClick={this.onClearRoom}>Clear room Estimate</button>
                </div>
            </div>
        );
    }

    render() {

        return (<div className="panel-body">
            <div className="container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <div className="panel panel-default">
                            <div className="panel-heading">Vote Room {this.props.roomID}</div>
                            <div className="panel-body">
                                {this.renderVotes()}
                                {this.renderVoteButtons()}
                            </div>
                        </div>
                        {this.renderAdminButtons()}
                    </div>
                </div>
            </div>
        </div>);
    }
}
