
function isTokenExpired(tokenKey) {

	const token =  localStorage.getItem(tokenKey)

	if(token===null)
		return true;

	//Check if the token is expired.
	if( JSON.parse(atob(token.split('.')[1])).exp < Date.now()/1000){
		
		localStorage.removeItem(tokenKey)

		return true;
	}

	return false;
}

export default isTokenExpired;
