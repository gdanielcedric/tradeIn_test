// src/plugins/axios.d.ts
import axios from 'axios';

declare module '../plugins/axios' {
  const axiosInstance: typeof axios;
  export default axiosInstance;
}
