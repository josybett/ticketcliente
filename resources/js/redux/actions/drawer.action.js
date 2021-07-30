import { SETOPEN } from "./../../constants/redux";

export const changeSetOpen = open => {
	return {
		type: SETOPEN,
		payload: open ? open : false
	}
}