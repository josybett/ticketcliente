import axios from 'axios';

/**
 * Función estándar de respuesta
 * @param {*} resp parámetro response de la api
 * @returns response de la api o error en el caso de falla en la conexión
 */
export const customResponse = resp => {
  if (resp.status === 200) return resp.data;
  const { response } = resp.data;
  
  throw new Error(response ? response : 'Server error, please try again or later!');
}

/**
 * Función estándar de error en la api
 * @param {*} error parámetro del error recibido de la api
 * @returns response con el error de api o error en el caso de falla en la conexión
 */
export const customResponseError = error => {
  const { data } = error.response;
  if (!data) throw new Error('Server error, please try again or later!');
  const { status, response } = data;
  if (status || status === false) {
    throw new Error(response ? response : 'Server error, please try again or later!');
  }

  return error.message;
}

/**
 * Función de consulta con método GET
 * @param {*} url string de la url de la api
 * @returns response de la api
 */
export const getMany = async (url) => {
  try {
    let data;
    await axios.get(url).then((response) => {
      data = customResponse(response);
    }).catch(error => {
      data = customResponseError(error);
    });

    return data;
  } catch (error) {
    throw new Error(error.message);
  }
}

/**
 * Función para insertar com método POST
 * @param {*} url string de la url de la api
 * @param {*} data json del body
 * @returns response de la api
 */
export const insert = async (url, data) => {
  try {
    let response;
    await axios.post(url, data).then((resp) => {
      if (resp.status >= 200 && resp.status <= 500) {
        response = customResponse(resp);
      }
    }).catch(error => {
      return customResponseError(error);
    });

    return response;    
  } catch (error) {
    throw new Error(error.message);
  }
}