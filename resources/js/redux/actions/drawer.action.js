import { SETOPEN } from "./../../constants/redux";

/**
 * Función tipo acción de Redux para cambiar status del drawer
 * @param {*} open boolean
 * @returns status del drawer
 */
export const changeSetOpen = open => {
	return {
		type: SETOPEN,
		payload: open ? open : false
	}
}