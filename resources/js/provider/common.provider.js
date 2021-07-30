import axios from 'axios';

export const customResponse = resp => {
  if (resp.status === 200) return resp.data;
  const { response } = resp.data;
  
  throw new Error(response ? response : 'Server error, please try again or later!');
}

export const customResponseError = error => {
  const { data } = error.response;
  if (!data) throw new Error('Server error, please try again or later!');
  const { status, response } = data;
  if (status || status === false) {
    throw new Error(response ? response : 'Server error, please try again or later!');
  }

  return error.message;
}

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

export const insert = async (url, data) => {
  try {
    let response;
    await axios.post(url, data).then((response) => {
      if (response.status >= 200 && response.status <= 500) {
        response = customResponse(response);
      }
    }).catch(error => {
      return customResponseError(error);
    });

    return response;    
  } catch (error) {
    throw new Error(error.message);
  }
}