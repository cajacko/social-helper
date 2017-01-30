export default function(response, req) {
  let data = response

  const auth = data.auth
  req.session.auth = auth

  delete data.auth

  return data
}
