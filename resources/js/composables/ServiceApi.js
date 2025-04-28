import api from '../axiosConfig';

export async function HttpGet(url) {
    try {
        const response = await api.get(url);
        if (response.status === 200) {
            return response;
        }
    } catch (error) {
        console.error("Erro no PUT:", error.response?.data || error.message);
        throw error;
    }
}

export async function HttpPost(url,data) {
    try {
        const response = await api.post(url, data);
        if (response.status === 201) {
            return response;
        }
    } catch (error) {
        console.error("Erro no POST:", error.response?.data || error.message);
        throw error;
    }
}

export async function HttpPut(url, data) {
    try {
        const response = await api.put(url, data);
        if (response.status === 201) {
            return response;
        }
    } catch (error) {
        console.error("Erro no PUT:", error.response?.data || error.message);
        throw error;
    }
}

export async function HttpDelete(url) {
    try {
        const response = await api.delete(url);
        if (response.status === 201) {
            return response;
        }
    } catch (error) {
        console.error("Erro no DELETE:", error.response?.data || error.message);
        throw error;
    }
}
