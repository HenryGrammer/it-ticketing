import axios from 'axios'

const url = process.env.MIX_APP_URL

const api = axios.create({
    baseURL: url,
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    }
})

export default api