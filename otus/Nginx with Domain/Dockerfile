FROM nginx

COPY ./mysite.local.conf /etc/nginx/conf.d/default.conf

COPY ./index.html /data/mysite.local/index.html

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

# docker build -t sf/nginx .
# docker build --no-cache -t sf/nginx .
# docker run -p 80:80 sf/nginx