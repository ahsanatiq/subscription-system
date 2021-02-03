FROM alpine
LABEL maintainer="Ahsan <me@ahsanatiq.info>"

RUN addgroup -S beanstalkd && adduser -S -G beanstalkd beanstalkd

RUN apk add --no-cache beanstalkd

RUN mkdir /data && chown beanstalkd:beanstalkd /data
VOLUME ["/data"]
EXPOSE 11300

ENTRYPOINT ["/usr/bin/beanstalkd", "-p", "11300", "-u", "beanstalkd"]
CMD ["-b", "/data"]