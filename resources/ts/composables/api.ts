// unwrapping the result in here as well

export default function <T>(url: string, method: string, token: string, values: object): Promise<T> {
  return fetch(url, {
    method,
    headers: {
      'content-type': 'application/json;charset=UTF-8',
      'accept': 'application/json',
    },
    body: JSON.stringify({ token, values }),
    mode: 'cors',
    cache: 'default',
  })
    .then((response) => {
      if (!response.ok)
        throw new Error(`${response.status}: ${response.statusText}`)

      return response.json() as Promise<T>
    })
    .then((data) => {
      return data
    })
}
