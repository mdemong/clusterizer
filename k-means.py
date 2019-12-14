import numpy as np
import random

fileText = '"'		# User file
dimension = 0		# Dimension type of values inputted
clusterNum = 0;		# Amount of Clusters

clusters = []		# total amount for each cluster
clusterNum = []     # total number of data points in each cluster

centroids = []		# Centroids used in the current model, will be placed at random locations
                    # This value will be a double because it holds the average value of all data points in the cluster

data_cluster =[]	# Array containing the connection between data points and centroids
                    # [ [data point], centroid index ]
                    # [ [data point], centroid index ]
                    # ...

data_points = []	# List containing all the data points


# This is the first function used as it initializes the global variables used in other methods
# This function takes input from the PHP webpage and converts it to a HashMap consisting of 
# INPUT fileText (String)    - Text of the user uploaded file
# INPUT dim (Integer)        - dimension of data points in the file
# INPUT clusterAmount (Integer) - amount of clusters the user defined
def km_init(fileText, dim, clusterAmount):
    dimension = dim
    max = 6
    min = 1
    
    # File Text is split into data points separated by array
    splitLine = fileText.split("\n")
    print(splitLine)
    
    for y in splitLine:
        dataPointInt = []
        dataPointString = y.split(" ")
        print(dataPointString)
        for x in dataPointString:
            if(x != ''):
                val = float(x)
                if(max < x): max = val
                if(min > x): min = val
                # Adding a value to the data point
                dataPointInt.append(val)
    
        # Append data point to list of data points
        if(len(dataPointInt)!= 0):
            data_points.append(dataPointInt)
            print("Data Point Int: ", dataPointInt, "\n")
    print("--------------------------------")

    # Generate centroids for the amount of clusters defined by the user
    for c in range(clusterAmount):
        c_data_point = []
        # Sets the total value of all the data points assigned to a centroid as [0,0,..] for each dimension
        cluster_total_data_point = []
        for i in range(dimension):
            c_data_point.append(random.randrange(min, max))
            cluster_total_data_point.append(0.0)
        centroids.append(c_data_point)
        clusterNum.append(0)
        clusters.append(cluster_total_data_point)

    # Assign centroids to data points using a the data_cluster 2 dimensional array
    index = 0;
    for p in data_points:
        # Outputs index of centroid this point is closes to
        c_index = compareCluster(p)
        cluster_assign = [p, c_index]
        
        # Add the data points value to the clusters array with an index based on the assigned centroid
        addPointCluster(p, c_index)
        
        print("\n\n This is the assigned cluster for a data point: ", cluster_assign)
        
        # Adds the data point as a key of the point and value of the  centroid's index in the array
        data_cluster.append(cluster_assign)
        index = index+1
    
    for x in data_cluster:
        print("\n Data Point, Cluster: ")
        print(x)
    print(data_cluster)


# This method carries out the algorithm

#def K-Means:
    # Since all the clusters have been assigned in the init, the average of the clusters must be computed for each centroid

# Eucilidian - this distance calculus is independent of dimensions.
# For example, a model with 4 dimensional points will have its distance computes as: d(a,b) = sqrt( (a1-b1)^2 + (a2-b2)^2 + (a3-b3)^2 + (a4-b4)^2 )
# INPUT p1, p2: Points to compare the Eucilidian distance between
def km_distance(p1, p2):
    total = 0
    # Allows selection for both data points as arrays
    for x, y in zip(p1, p2):
        total += np.square((x-y))
    return np.sqrt(total)

# This method compares the distance between a point and all of the Centroids in the centroids array
# INPUT p: Point to compare with all the centroids
def compareCluster(p):
    dist = km_distance(p, centroids[0])
    centroid = 0;
    index = 0;
    for x in centroids:
        val = km_distance(p, x)
        if(val < dist):
            dist = val
            centroid = index
        index = index + 1
    return centroid

# This method computes the average of all the data points assigned and assigns this value to the centroid
#def updateCentroid(c):

def addPointCluster(p, c):
    clust_t_dp = clusters[c]
    clusterNum[c] = clusterNum[c] + 1
    
    print p
    print clust_t_dp
    
    index = 0
    for dp, cl in zip(p, clust_t_dp):
        print("This is the aftermath of adding the values ", cl, " and ", dp, " value:" ,cl)
        clust_t_dp[index] = cl + dp
        index = index+1
    
    print("For point", p, "this is the total value of the cluster at ", c, ": ", clust_t_dp)
    print("This is the clusters array: ", clusters, " and the numbers array: ", clusterNum)
    print()
    print()


print("Hello World")
str = "1 2 \n 3 4 \n 5 6\n"
di = 2
ca = 2
km_init(str, di, ca)
