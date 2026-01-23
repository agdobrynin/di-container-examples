FROM php:8.1-cli-alpine
ARG UID
ARG GID
ARG APP_DIR
ENV UID=${UID}
ENV GID=${GID}


RUN mkdir $APP_DIR && \
    curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer && \
    addgroup -g $GID -S dev &&  \
    adduser -u $UID -S dev --ingroup dev && \
    chown -R $UID:$GID $APP_DIR

USER dev
WORKDIR $APP_DIR
