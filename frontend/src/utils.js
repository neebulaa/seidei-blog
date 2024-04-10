import axios from "axios";

import { APP_NAME, API_URL } from "./config";

const fetching = async (method, path, options = {}) => {
	const headers = {
		"Content-Type": "application/json",
		Accept: "application/json",
	};
	const token = localStorage.getItem(`${APP_NAME}_TOKEN`);
	headers["Authorization"] = `Bearer ${token}`;

	options.headers = {
		...headers,
		...options.headers,
	};

	try {
		const res = await axios({
			method: method,
			url: `${API_URL}/${path}`,
			...options,
		});
		return {
			status: res.status,
			data: res.data
		};
	} catch (err) {
		return {
			status: err.response.status,
			data: err.response.data
		};
	}
};

export { fetching };
