# VERSION defines the version for the docker containers.
# To build a specific set of containers with a version,
# you can use the VERSION as an arg of the docker build command (e.g make docker VERSION=0.0.2)

# REGISTRY defines the registry where we store our images.
# To push to a specific registry,
# you can use the REGISTRY as an arg of the docker build command (e.g make docker REGISTRY=my_registry.com/username)
# You may also change the default value if you are using a different registry as a default
REGISTRY ?= henrotaym

# PROJECT defines suffix for images built & stored to docker hub.
PROJECT ?= task-trustup-io

# Commands
deploy: docker-build docker-push kubernetes-deploy

docker-build: guard-VERSION
	docker build -f Dockerfile.prod . --target cli -t ${REGISTRY}/${PROJECT}-cli:${VERSION} & \
	docker build -f Dockerfile.prod . --target cron -t ${REGISTRY}/${PROJECT}-cron:${VERSION} & \
	docker build -f Dockerfile.prod . --target fpm_server -t ${REGISTRY}/${PROJECT}-fpm:${VERSION} & \
	docker build -f Dockerfile.prod . --target web_server -t ${REGISTRY}/${PROJECT}-web:${VERSION} & \
	wait
	echo "Images were successfully built."
 
docker-push: guard-VERSION
	docker push ${REGISTRY}/${PROJECT}-cli:${VERSION} & \
	docker push ${REGISTRY}/${PROJECT}-cron:${VERSION} & \
	docker push ${REGISTRY}/${PROJECT}-fpm:${VERSION} & \
	docker push ${REGISTRY}/${PROJECT}-web:${VERSION} & \
	wait
	echo "Images were successfully pushed."

kubernetes-deploy: guard-VERSION
	APP_VERSION=${VERSION} kubectl kustomize ./kubernetes | kubectl apply -f -

guard-%:
	@ if [ "${${*}}" = "" ]; then \
		echo "$* is missing"; \
    	exit 1; \
	fi