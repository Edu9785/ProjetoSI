package com.example.nexeltools.modelo;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.toolbox.HttpHeaderParser;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.Collections;
import java.util.HashMap;
import java.util.Map;

public abstract class VolleyMultipartRequest extends Request<NetworkResponse> {
    private final Response.Listener<NetworkResponse> mListener;
    private final Map<String, String> mHeaders;
    private final Map<String, String> mParams;
    private final Map<String, DataPart> mByteData;

    public VolleyMultipartRequest(int method, String url,
                                  Response.Listener<NetworkResponse> listener,
                                  Response.ErrorListener errorListener) {
        super(method, url, errorListener);
        this.mListener = listener;
        this.mHeaders = new HashMap<>();
        this.mParams = new HashMap<>();
        this.mByteData = new HashMap<>();
    }

    @Override
    protected Map<String, String> getParams() {
        return mParams;
    }

    public void addParam(String key, String value) {
        mParams.put(key, value);
    }

    public void addFile(String key, DataPart dataPart) {
        mByteData.put(key, dataPart);
    }

    @Override
    public Map<String, String> getHeaders() throws AuthFailureError {
        return (mHeaders != null) ? mHeaders : super.getHeaders();
    }

    @Override
    public String getBodyContentType() {
        return "multipart/form-data;boundary=" + BOUNDARY;
    }

    @Override
    public byte[] getBody() throws AuthFailureError {
        ByteArrayOutputStream bos = new ByteArrayOutputStream();
        try {
            if (mParams != null && !mParams.isEmpty()) {
                for (Map.Entry<String, String> entry : mParams.entrySet()) {
                    writeStringData(bos, entry.getKey(), entry.getValue());
                }
            }
            if (mByteData != null && !mByteData.isEmpty()) {
                for (Map.Entry<String, DataPart> entry : mByteData.entrySet()) {
                    writeFileData(bos, entry.getKey(), entry.getValue());
                }
            }
            bos.write(("--" + BOUNDARY + "--\r\n").getBytes());
        } catch (IOException e) {
            e.printStackTrace();
        }
        return bos.toByteArray();
    }

    @Override
    protected Response<NetworkResponse> parseNetworkResponse(NetworkResponse response) {
        return Response.success(response, HttpHeaderParser.parseCacheHeaders(response));
    }

    @Override
    protected void deliverResponse(NetworkResponse response) {
        mListener.onResponse(response);
    }

    private void writeStringData(ByteArrayOutputStream bos, String key, String value) throws IOException {
        bos.write(("--" + BOUNDARY + "\r\n").getBytes());
        bos.write(("Content-Disposition: form-data; name=\"" + key + "\"\r\n\r\n").getBytes());
        bos.write(value.getBytes());
        bos.write("\r\n".getBytes());
    }

    private void writeFileData(ByteArrayOutputStream bos, String key, DataPart dataPart) throws IOException {
        bos.write(("--" + BOUNDARY + "\r\n").getBytes());
        bos.write(("Content-Disposition: form-data; name=\"" + key + "\"; filename=\"" + dataPart.getFileName() + "\"\r\n").getBytes());
        bos.write(("Content-Type: " + dataPart.getType() + "\r\n\r\n").getBytes());
        bos.write(dataPart.getContent());
        bos.write("\r\n".getBytes());
    }

    protected abstract Map<String, DataPart> getByteData();

    public static class DataPart {
        private final String fileName;
        private final byte[] content;
        private final String type;

        public DataPart(String fileName, byte[] content) {
            this.fileName = fileName;
            this.content = content;
            this.type = "image/jpeg";
        }

        public String getFileName() {
            return fileName;
        }

        public byte[] getContent() {
            return content;
        }

        public String getType() {
            return type;
        }

        private String getMimeType(String fileName) {
            if (fileName.toLowerCase().endsWith(".png")) {
                return "image/png";
            } else {
                return "image/jpeg"; // Padrão é JPEG
            }
        }
    }

    private static final String BOUNDARY = "multipart-" + System.currentTimeMillis();
}
