import numpy as np
import random

import fileinput
import sys

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
def km_init(fileText, dim, num):
    
    dimension = dim
    clusterAmount = num
    
    max = float(fileText[0])
    min = float(fileText[0])
    # File Text is split into data points separated by array
    splitLine = fileText.split("\\n")
   
    for y in splitLine:
        dataPointInt = []
        dataPointString = y.split(" ")
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

    # Generate centroids for the amount of clusters defined by the user
    for c in range(clusterAmount):
        # Array holding the centroid point
        c_data_point = []
        
        # Array holding the the total value of all the data points assigned to a centroid as [0,0,..] for each dimension
        cluster_total_data_point = []
        
        for i in range(dimension):
            # Adds randomized centroid points for each centroid
            c_data_point.append(random.randrange(min, max))
            
            # Initializes the array with 0 because the total data point values haven't been used and assigned to clusters
            cluster_total_data_point.append(0.0)
        
        # Initializes each amount of data points attached to a cluster to 0
        clusterNum.append(0)
        centroids.append(c_data_point)
        clusters.append(cluster_total_data_point)

        # print "This is the initial centroids: "
#       for a in centroids:
#   print(a)

    # Assign centroids to data points using a the data_cluster 2 dimensional array
    for p in data_points:
        
        # Outputs index of centroid this point is closest to and creates an array to hold this tuple
        c_index = compareCluster(p)
        cluster_assign = [p, c_index]
        
        # Calls a method that adds the data points value to the clusters array with an index based on the assigned centroid
        addPointCluster(p, c_index)

        # Adds the data point as a key of the point and value of the  centroid's index in the array
        data_cluster.append(cluster_assign)

    KMeans(clusterAmount)


# This method carries out the algorithm by utilizing the updateDataPoints method
# Since the k-init method assigns the initial data points to the clusters, this method will start off with updating centroids
def KMeans(clusterAmount):
    ogCentroids =[]
    
    # Keep the original centroid values
    for a in centroids:
        copy = []
        for p in a:
            copy.append(p)
        ogCentroids.append(copy)

    # Since the k_init method initialized the data points, this must be done outside a loop
    updateCentroids(clusterAmount)

    index = 0
    carry_on = True
    # While the original centroids and the updated centroids are not the same, the algorithm will continue to find new clusters for the data points
    while(carry_on):
        check =checkOG(ogCentroids)
        ogCentroids = []
        if(check == False):
            # Update the data points with the new centroids
            updateDataPoints()
            # Keep the original centroid values
            for a in centroids:
                copy = []
                for p in a:
                    copy.append(p)
                ogCentroids.append(copy)

            # Call method to update the centroids
            updateCentroids(clusterAmount)
            index = index+1
        else:
            break

    print "This is the final data_cluster: "
    print "Format: [data point], [cluster value]"
    print
    for a in data_cluster:
        print(a)
    print
    print "These are the final centroid values: "
    index = 0;
    for a in centroids:
        print("Cluster ", index, " :", a)
        index = index+1

# This method compares an array with the current centroids array
# INPUT og: Array to be compared with the centroids array
# OUTPUT: True if the arrays are the same, False if the arrays are different
def checkOG(og):
    index = 0
    for b in centroids:
        if(og[index] != b):
            return False
        index = index+1
    return True


# Eucilidian - this distance calculus is independent of dimensions.
# For example, a model with 4 dimensional points will have its distance computes as: d(a,b) = sqrt( (a1-b1)^2 + (a2-b2)^2 + (a3-b3)^2 + (a4-b4)^2 )
# INPUT p1, p2: Points to compare the Eucilidian distance between
# OUTPUT: Distance between the two points
def km_distance(p1, p2):
    total = 0
    
    # Allows selection for both data points as arrays
    index = 0
    for y in p2:
        total += np.square((p1[index]-p2[index]))
    return np.sqrt(total)

# This method compares the distance between a point and all of the Centroids in the centroids array
# INPUT p: Point to compare with all the centroids
# OUTPUT: Index of the centroid the point is closest to
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

# This method assigns a point to the designated cluster along with incrementing the amount of data points attached to the specific cluster
# INPUT p: Point to attached to cluster
# INPUT c: Index of the centroid value to be attached to
def addPointCluster(p, c):
    
    # Extracts the cluster's centroid points at this value
    clust_t_dp = clusters[c]
    
    # Increments the amount of data points attached to a cluster
    clusterNum[c] = clusterNum[c] + 1

    # Adds each data point's dimensional point to the cluster's corelating point EX. p = [2, 4] and c = [3, 5]  >> c = [5, 9]
    index = 0
    for dp, cl in zip(p, clust_t_dp):
        clust_t_dp[index] = cl + dp
        index = index+1

# This method updates the Data Points attached cluster based on which cluster is the closest
# By looping through all the centroids in the clusters, the data points compare the distance and choose the closest centroid to attach to
def updateDataPoints():
    # Assign centroids to data points using a the data_cluster 2 dimensional array
    index = 0
    
    for x in data_cluster:
        dp_cluster_combo = data_cluster[index]
        point = dp_cluster_combo[0]
        
        # Outputs index of centroid this point is closest to and creates an array to hold this tuple
        c_index = compareCluster(point)
        cluster_assign = [point, c_index]
        
        # Calls a method that adds the data points value to the clusters array with an index based on the assigned centroid
        addPointCluster(point, c_index)
        
        # Adds the data point as a key of the point and value of the  centroid's index in the array
        data_cluster[index] = cluster_assign
        index = index + 1


# This method computes the average of all the data points assigned and assigns this value to the centroid
# Since all the clusters have been assigned in the init or the k-means function, the average of the clusters must be computed for each centroid
# INPUT num: Cluster Amount
def updateCentroids(num):
    for i in range(num):
        currentCentroid = centroids[i]
        currentTotal = clusters[i]
        currentNum = clusterNum[i]
        index = 0
        for a, b in zip(currentCentroid, currentTotal):
            if(currentNum != 0):
                average = float((a + b)/currentNum)
            else:
                # The average value is 0 if there are no data points in a cluster
                average = 0
            currentCentroid[index] = average
            currentTotal[index] = 0
            index = index+1
        clusterNum[i] = 0

text = sys.argv[1].split('Z')
if(len(text) == 3):
    dim = int(text[1])
    num = int(text[2])
    km_init(text[0], dim, num);
else:
   print "The input values are too short."

sys.stdout.flush
sys.stdin.close
sys.stdout.close
