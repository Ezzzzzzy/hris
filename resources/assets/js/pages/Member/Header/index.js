import React from "react";
import styles from "./style.js";
import { Link } from "react-router-dom";

const StatusHeader = props => {
	return (
		<div className="container-fluid">
			<div className="row" style={styles["header-container"]}>
				<div className="col-6">
					<span style={styles["header-text"]}>{props.title}</span>
				</div>

				{props.type && (
					<div className="col-4 offset-2">
						<Link
							to="/member/add"
							className="btn btn-sm btn-success custm-btn-division"
						>
							<i className="fas fa-cloud-download-alt fa-fw custm-btn-icons" />
							Download Profile
						</Link>

						<Link
							to={`/member/edit/${props.memberId}`}
							className="btn btn-sm btn-success custm-btn-division"
						>
							<i className="fas fa-edit fa-fw custm-btn-icons" />
							Edit Profile
						</Link>
					</div>
				)}
			</div>
		</div>
	);
};

export default StatusHeader;
